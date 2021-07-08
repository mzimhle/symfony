<?php

namespace App\Controller;
// Standard Includes
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
// Requests
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
// Datatables
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
// Entity
use App\Entity\Member;
// DTO
use App\DTO\MemberDTO;
// Form
use App\Form\MemberForm;
// Query
use Doctrine\ORM\QueryBuilder;

class HomeController extends AbstractController
{
    /**
     * Landing page for the website
     * 
     * @param Request $request
     * @param DataTableFactory $dataTableFactory	 
     * @return Response
     *	
     * @Route("/", name="app_home")
     */
    public function index(Request $request, DataTableFactory $dataTableFactory): Response
    {
	
        $table = $dataTableFactory->create()
            ->add('name', TextColumn::class, ['label' => 'Name'])
            ->add('surname', TextColumn::class, ['label' => 'Surname'])
            ->add('cellphone', TextColumn::class, ['label' => 'Cellphone Number'])
            ->add('email', TextColumn::class, ['label' => 'Email Address'])
			->createAdapter(ORMAdapter::class, [
				'entity' => Member::class,
				'query' => function (QueryBuilder $builder) {
					$builder->select('m')
					->from('App\Entity\Member', 'm');
				}
			])
            ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }
        return $this->render('home/index.html.twig', ['datatable' => $table]);
    }

    /**
     * Add a new member page
     * 
     * @param Request $request
     * @return Response
	 *
     * @Route("/add", name="app_add")
     */
    public function add(Request $request)
    {
        // populate the DTO with default values
        $memberDTO = new MemberDTO($this->getDoctrine()->getManagerForClass(Member::class));
        return $this->handleMemberDTO($request, $memberDTO);
    }	
	
    /**
     * Edit a new member page
     * 
     * @param Request $request
     * @param Member $member
     * @return Response
	 *
     * @Route("/edit/{id}", name="app_edit", requirements={"id"="\d+"})
     * @ParamConverter("Member", class="App\Entity\Member")
     */
    public function edit(Request $request, Member $member)
    {
        // Prep the DTO with existing values
        $memberDTO = new MemberDTO($this->getDoctrine()->getManagerForClass(Member::class));
        $memberDTO->name = $member->getName();
        $memberDTO->surname = $member->getSurname();
        $memberDTO->cellphone = $member->getCellphone();
        $memberDTO->email = $member->getEmail();
		
        return $this->handleMemberDTO($request, $memberDTO);
    }
    /**	 
     * Process adding and updating of a member
     * 
     * @param Request $request
     * @param MemberDTO $memberDTO
     */
    private function handleMemberDTO(Request $request, MemberDTO $memberDTO, ?Member $member = null)
    {
        $memberForm = $this->createForm(MemberForm::class, $memberDTO);

        $memberForm->handleRequest($request);

        if ($memberForm->isSubmitted()) {
            if ($memberForm->isValid()) {

                if (null === $member) {
                    $member = new Member();
                }

                $member->setName($memberDTO->name);
                $member->setSurname($memberDTO->surname);
                $member->setCellphone($memberDTO->cellphone);
                $member->setEmail($memberDTO->email);

                $sem = $this->getDoctrine()->getManagerForClass(Member::class);
                $sem->persist($member);
                $sem->flush();
                $this->addFlash('success', 'The member was saved successfully!');
                return $this->redirectToRoute('app_home');
            }
        }

        return $this->render('home/form.html.twig', [
			'memberForm' => $memberForm->createView(),
			'member' => $member
		]);
    }	
}
